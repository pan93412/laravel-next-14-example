"use server";

import api from "@/fetcher/endpoint";
import {
  Student,
  StudentDeleteDto,
  StudentPUpdateDto,
  StudentRequestDto,
  Students,
  StudentSchema,
  StudentsSchema,
} from "@/fetcher/student.types";
import { revalidateTag } from "next/cache";

export async function getAllStudents(): Promise<Students> {
  const response = await fetch(api("students"), {
    next: {
      tags: ["student"],
    },
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to receive students due to (${response.status}) ${raw}`);
  }

  const json = await response.json();
  return StudentsSchema.parse(json);
}

export async function createStudent(student: StudentRequestDto): Promise<Student> {
  const response = await fetch(api("students"), {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(student),
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to create student due to (${response.status}) ${raw}`);
  }

  revalidateTag("student");
  const json = await response.json();
  return StudentSchema.parse(json);
}

export async function deleteStudent(student: StudentDeleteDto): Promise<void> {
  const response = await fetch(api("students/" + student.id), {
    method: "DELETE",
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to delete student (${student.id}) due to (${response.status}) ${raw}`);
  }

  revalidateTag("student");
}

export async function partialUpdateStudent(id: string, student: StudentPUpdateDto): Promise<void> {
  const body = JSON.stringify(student);

  const response = await fetch(api("students/" + id), {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body,
  });
  if (!response.ok) {
    const raw = await response.text();
    throw new Error(`Unable to update student (${id} => ${body}) due to (${response.status}) ${raw}`);
  }

  revalidateTag("student");
}
